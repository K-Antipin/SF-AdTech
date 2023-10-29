let DragManager = new function () {

    /**
     * составной объект для хранения информации о переносе:
     * {
     *   elem - элемент, на котором была зажата мышь
     *   avatar - аватар
     *   downX/downY - координаты, на которых был mousedown
     *   shiftX/shiftY - относительный сдвиг курсора от угла элемента
     * }
     */

    let dragObject = {};
    let currentDroppable = null;
    let self = this;

    function onMouseDown(e) {
        if (e.which != 1) return;

        let elem = e.target.closest('.draggable');
        if (!elem) return;

        dragObject.elem = elem;
        // запомним, что элемент нажат на текущих координатах pageX/pageY
        dragObject.downX = e.pageX;
        dragObject.downY = e.pageY;

        return false;
    }

    function onMouseMove(e) {
        if (!dragObject.elem) return; // элемент не зажат

        if (!dragObject.avatar) { // если перенос не начат...
            let moveX = e.pageX - dragObject.downX;
            let moveY = e.pageY - dragObject.downY;

            // если мышь передвинулась в нажатом состоянии недостаточно далеко
            if (Math.abs(moveX) < 3 && Math.abs(moveY) < 3) {
                return;
            }

            // начинаем перенос
            dragObject.avatar = createAvatar(e); // создать аватар
            if (!dragObject.avatar) { // отмена переноса, нельзя "захватить" за эту часть элемента
                dragObject = {};
                return;
            }

            // аватар создан успешно
            // создать вспомогательные свойства shiftX/shiftY
            let coords = getCoords(dragObject.avatar);
            dragObject.shiftX = dragObject.downX - coords.left;
            dragObject.shiftY = dragObject.downY - coords.top;

            // let droppableBelow = e.target.closest('.draggable');
            startDrag(e); // отобразить начало переноса
        }

        // отобразить перенос объекта при каждом движении мыши
        dragObject.avatar.style.left = e.pageX - dragObject.shiftX + 'px';
        dragObject.avatar.style.top = e.pageY - dragObject.shiftY + 'px';

        //подсвечиваем таргет
        e.target.hidden = true;
        let elemBelow = document.elementFromPoint(e.clientX, e.clientY);
        e.target.hidden = false;

        let droppableBelow = elemBelow.closest('.droppable');

        if (currentDroppable != droppableBelow) {
            // мы либо залетаем на цель, либо улетаем из неё
            // внимание: оба значения могут быть null
            //   currentDroppable=null,
            //     если мы были не над droppable до этого события (например, над пустым пространством)
            //   droppableBelow=null,
            //     если мы не над droppable именно сейчас, во время этого события

            if (currentDroppable) {
                // логика обработки процесса "вылета" из droppable (удаляем подсветку)
                currentDroppable.style.background = '';
            }
            currentDroppable = droppableBelow;
            if (currentDroppable) {
                // логика обработки процесса, когда мы "влетаем" в элемент droppable
                currentDroppable.style.background = 'pink';
            }
        }

        return false;
    }

    function onMouseUp(e) {
        // e.target.hidden = true;
        // let elemBelow = document.elementFromPoint(e.clientX, e.clientY);
        // e.target.hidden = false;

        // e.target.focus();

        // let droppableBelow = elemBelow.closest('.droppable');

        // if (droppableBelow) {
        //     droppableBelow.style.background = '';
        // }
        document.querySelectorAll('.droppable')
            .forEach(el => {
                el.style.background = '';
            });

        if (dragObject.avatar) { // если перенос идет
            finishDrag(e);
        }

        // перенос либо не начинался, либо завершился
        // в любом случае очистим "состояние переноса" dragObject
        dragObject = {};
    }

    function finishDrag(e) {
        let dropElem = findDroppable(e);
        if (!dropElem) {
            self.onDragCancel(dragObject);
        } else {

            if (
                (dragObject.downX < window.innerWidth / 2 && getCoords(dropElem).left > window.innerWidth / 2)
                ||
                (dragObject.downX > window.innerWidth / 2 && getCoords(dropElem).left < window.innerWidth / 2)
            ) {
                let id = dragObject.avatar.querySelector('a[href]').getAttribute('data-offer-id');
                let table = dragObject.avatar.querySelector('a[href]').getAttribute('data-table');
                let url = parseInt(dragObject.avatar.querySelector('a[href]').getAttribute('data-offer-status')) ? '/admin/offers/zip' : '/admin/offers/unzip?id=' + id + '&table=' + table;
                let method = parseInt(dragObject.avatar.querySelector('a[href]').getAttribute('data-offer-status')) ? 'POST' : false;
                let data = {
                    id: id,
                    table: table
                };
                let res = send_data(url, method, data, dragObject);
                res.then(([r, dragObject]) => {
                    if (r) {
                        parseInt(dragObject.avatar.querySelector('a[href]').getAttribute('data-offer-status')) ? dragObject.avatar.querySelector('a[href]').setAttribute('data-offer-status', 0) : dragObject.avatar.querySelector('a[href]').setAttribute('data-offer-status', 1);
                    } else {
                        self.onDragCancel(dragObject);
                    }
                });
            }
            dragObject.avatar.style = '';
            dropElem.append(dragObject.avatar);
        }
    }

    function createAvatar(e) {
        //добавим возможность перетаскивать только за границу
        if (!e.target.classList.contains('draggable')) return;

        // запомнить старые свойства, чтобы вернуться к ним при отмене переноса
        let avatar = dragObject.elem;
        let old = {
            parent: avatar.parentNode,
            nextSibling: avatar.nextSibling,
            position: avatar.position || '',
            left: avatar.left || '',
            top: avatar.top || '',
            zIndex: avatar.zIndex || ''
        };

        // функция для отмены переноса
        avatar.rollback = function () {
            old.parent.insertBefore(avatar, old.nextSibling);
            avatar.style.position = old.position;
            avatar.style.left = old.left;
            avatar.style.top = old.top;
            avatar.style.zIndex = old.zIndex
        };

        return avatar;
    }

    function startDrag(e) {
        let avatar = dragObject.avatar;

        // инициировать начало переноса
        document.body.appendChild(avatar);
        avatar.style.zIndex = 9999;
        avatar.style.position = 'absolute';
    }

    function findDroppable(event) {
        // спрячем переносимый элемент
        dragObject.avatar.hidden = true;

        // получить самый вложенный элемент под курсором мыши
        let elem = document.elementFromPoint(event.clientX, event.clientY);

        // показать переносимый элемент обратно
        dragObject.avatar.hidden = false;

        if (elem == null) {
            // такое возможно, если курсор мыши "вылетел" за границу окна
            return null;
        }


        let droppable = elem.closest('.droppable');
        if (droppable) {
            return droppable;
        }
        return null;
    }

    document.onmousemove = onMouseMove;
    document.onmouseup = onMouseUp;
    document.onmousedown = onMouseDown;

    this.onDragEnd = function (dragObject, dropElem) { };
    this.onDragCancel = function (dragObject) { };

};


function getCoords(elem) { // кроме IE8-
    let box = elem.getBoundingClientRect();

    return {
        top: box.top + scrollY,
        left: box.left + scrollX
    };

}

async function send_data(url, method = false, data = false, dragObject) {
    if (method && data) {
        let formData = new FormData();
        Object.entries(data).forEach((entry) => {
            const [key, value] = entry;
            formData.append(key, value);
        });
        let response = await fetch(url, {
            method: method,
            headers: {
                'ContentType': 'application/json;charset=utf-8'
            },
            body: formData
        });
        let result = await response.json();
        if (result) return [result, dragObject];
        return [false, dragObject];
    } else {
        let response = await fetch(url);
        let result = await response.json();
        if (result) return [result, dragObject];
        return [false, dragObject];
    }
}

async function send_form(url, form) {
    let response = await fetch(url, {
        method: 'POST',
        headers: {
            'ContentType': 'application/json;charset=utf-8'
        },
        body: new FormData(form)
    });
    let result = await response.json();
    if (result) return result;
    return false;
}


//Рефакторинг старого кода
//не стал переделывать разметку из-за использования fetch

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('#add_offer_button')) {
        document.querySelector('#add_offer_button')
            .addEventListener('click', (e) => {
                e.preventDefault();
                document.querySelector('#add_offer')
                    .classList.add('add_offer_active');
            });
    }

    if (document.querySelector('#add_offer_close')) {
        document.querySelector('#add_offer_close')
            .addEventListener('click', () => {
                document.querySelector('#add_offer')
                    .classList.remove('add_offer_active');
            });
    }

    if (document.querySelectorAll('.url_hash')) {
        document.querySelectorAll('.url_hash').forEach(el => {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                let target = e.target;
                let rng, sel;
                if (document.createRange) {
                    rng = document.createRange();
                    rng.selectNode(target)
                    sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(rng);
                } else {
                    let rng = document.body.createTextRange();
                    rng.moveToElementText(target);
                    rng.select();
                }
            });
        });
    }

    if (document.forms.add_offer) {
        let add_form = document.forms.add_offer;
        add_form.addEventListener('submit', function (e) {
            e.preventDefault();
            let form = e.target;
            let id;
            send_form('/admin/offers/add', form)
                .then(result => {
                    if (typeof result === 'object') {
                        Object.keys(result).forEach(key => {
                            let input = e.target.querySelector('[name="' + key + '"]');
                            input.classList.add('is-invalid');
                            input.value = 'Поле заполнено некорректно';
                        });
                    } else {
                        id = result;
                        let name = form.name.value;
                        let price = form.price.value;
                        let url = form.url.value;
                        let a = document.createElement('a');
                        a.href = '/offer?id=' + id;
                        a.className = 'card text-decoration-none offers__item move draggable';
                        a.setAttribute('data-offer-id', id);
                        a.setAttribute('data-offer-status', 1);
                        a.innerHTML = '<div class="card-body"><h5 class="card-title">' + name + '</h5><p class="card-text">Цена <span class="badge bg-warning warn__badge">' + price + '</span></p><p class="card-text">' + url + '</p></div>';
                        document.querySelector('#activ_offers').append(a);


                        document.querySelector('#add_offer')
                            .classList.remove('add_offer_active');
                    }
                });
        });
    }

    if (document.forms.subscribe_form) {
        let subscribe_form = document.forms.subscribe_form;
        subscribe_form.addEventListener('submit', function (e) {
            e.preventDefault();
            let form = e.target;
            send_form('/admin/offers/subscribe', form)
                .then(result => {
                    if (result) {
                        let div = subscribe_form.parentNode;
                        div.innerHTML = '<h5>Вы подписаны</h5>';
                    }
                });
        });
    }

    if (document.forms.statistics_form) {
        let statistics_form = document.forms.statistics_form;
        statistics_form.addEventListener('submit', function (e) {
            e.preventDefault();
            let form = e.target;
            send_form('/statistics', form)
                .then(result => {
                    if (result && result.result.length > 0) {
                        let stats = document.querySelector('#statistics');
                        let cost = 0;
                        let res = result.result;
                        stats.innerHTML = '';
                        for (let i = 0; i < res.length; i++) {
                            cost += parseFloat(res[i].price);
                        }
                        cost = result.user == 'admin' ? cost * 0.2 : result.user == 'webmaster' ? cost * 0.8 : cost;
                        let text = result.user == 'advertiser' ? 'Расход' : 'Доход';
                        let div = document.createElement('div');
                        div.className = 'ms-3 col-sm-6 col-md-4 col-lg-3';
                        div.innerHTML = '<div class="card"><div class="card-body"><p class="card-text">Переходов: ' + res.length + '</p><p class="card-text">' + text + ': ' + cost + '</p></div></div>';
                        stats.append(div);
                    } else {
                        let stats = document.querySelector('#statistics');
                        let div = document.createElement('div');
                        stats.innerHTML = '';
                        div.className = 'ms-3 col-sm-6 col-md-4 col-lg-3';
                        div.innerHTML = '<div class="card"><div class="card-body"><p class="card-text">Нет статистики за данный период</p></div></div>';
                        stats.append(div);
                    }
                });
        });
        document.querySelector('#day').addEventListener('click', () => {
            statistics_form.date_from.value = new Date().toISOString().split('T')[0];
            statistics_form.date_to.value = new Date().toISOString().split('T')[0];
            statistics_form_button.click();
        });
        document.querySelector('#month').addEventListener('click', () => {
            let date = new Date();
            statistics_form.date_from.value = new Date(date.getFullYear(), date.getMonth(), 2).toISOString().split('T')[0];
            statistics_form.date_to.value = new Date(date.getFullYear(), date.getMonth() + 1, 1).toISOString().split('T')[0];
            statistics_form_button.click();
        });
        document.querySelector('#year').addEventListener('click', () => {
            let date = new Date();
            statistics_form.date_from.value = new Date(date.getFullYear(), 0, 2).toISOString().split('T')[0];
            statistics_form.date_to.value = new Date(date.getFullYear(), 12, 1).toISOString().split('T')[0];
            statistics_form_button.click();
        });
    }

    // if (document.querySelector('#register_form')) {
    //     let form = document.querySelector('#register_form');
    //     form.addEventListener('submit', function (e) {
    //         e.preventDefault();
    //         let form = e.target;
    //         if(form.action.indexOf("register") >= 0) form.submit();
    //         send_form(form.action, form)
    //             .then(result => {
    //                 if (result) {
    //                     let pop_up = document.querySelector('#pop_up_ok');
    //                     pop_up.classList.add('pop_up_ok_active');
    //                     setTimeout(() => {
    //                         pop_up.classList.remove('pop_up_ok_active');
    //                         // form.reset();
    //                     }, 1000);
    //                 }
    //             });
    //     });
    // }
});
