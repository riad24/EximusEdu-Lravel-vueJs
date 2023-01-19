import VueSimpleAlert from "vue3-simple-alert";
import {askEnum, statusEnum} from "../enums";
import store from '../store';

export default {
    modalToggle: function () {
        $('#modal').modal('toggle');
    },

    modalShow: function (id = 'modal') {
        $('#' + id).modal('show');
    },

    modalHide: function (id = 'modal') {
        $('#' + id).modal('hide');
    },

    phoneNumber: function (e) {
        let char = String.fromCharCode(e.keyCode);
        if (/^[+]?[0-9]*$/.test(char)) return true;
        else e.preventDefault();
    },

    floatNumber: function (e) {
        let char = String.fromCharCode(e.keyCode);
        if (/^[.]?[0-9]?[.]*$/.test(char)) return true;
        else e.preventDefault();
    },



    destroyConfirmation: function () {
        return new VueSimpleAlert.confirm('You will not be able to recover the deleted record!', 'Are you sure?', 'warning', {
            confirmButtonText: 'Yes, Delete it!',
            cancelButtonText: 'No, Cancel!',
            confirmButtonColor: '#696cff',
            cancelButtonColor: '#8592a3',
        })
    },

    recursiveRouter: function (routes, permission) {
        let i, j;
        for (i = 0; i < routes.length; i++) {
            for (j = 0; j < permission.length; j++) {
                if (typeof routes[i].meta !== "undefined" && routes[i].meta) {
                    if (typeof routes[i].meta.permissionUrl !== "undefined" && routes[i].meta.permissionUrl) {
                        if (routes[i].meta.permissionUrl === permission[j].url) {
                            routes[i].meta.access = permission[j].access;
                            routes[i].meta.title = permission[j].title;
                        }

                        if (typeof routes[i].children !== "undefined" && routes[i].children) {
                            this.recursiveRouter(routes[i].children, permission);
                        }
                    }
                }
            }
        }
    },

    textShortener: function (text, number = 30) {
        if (text) {
            if (!(text.length < number)) {
                return text.substring(0, number) + "..";
            }
        }
        return text;
    },

    statusClass: function (status) {
        if (status === statusEnum.ACTIVE) {
            return 'badge bg-label-success me-1';
        } else {
            return 'badge bg-label-danger me-1';
        }
    },

    askClass: function (ask) {
        if (ask === askEnum.YES) {
            return 'badge bg-label-success me-1';
        } else {
            return 'badge bg-label-danger me-1';
        }
    },


    requestHandler: function (requests) {
        let i = 1;
        let what = '?';
        let response = '';

        for (let request in requests) {
            if (requests[request] !== '' && requests[request] !== null) {
                if (i !== 1) {
                    response += '&';
                }
                response += request + '=' + requests[request];
            }
            i++;
        }

        if (response) {
            response = what + response
        }

        return response;
    },

    offCanvas: function () {
        $('#offcanvasBackdrop').offcanvas('toggle');
    },

    permissionChecker: function (permissionName) {
        let i, permissions = store.getters.authPermission;
        for (i = 0; i < permissions.length; i++) {
            if (typeof permissions[i].name !== "undefined" && permissions[i].name) {
                if (permissions[i].name === permissionName) {
                    return permissions[i].access;
                }
            }
        }
    },

    formDataShow: function (formData) {
        for (let pair of formData.entries()) {
            console.log(pair[0] + ' : ' + pair[1]);
        }
    },
}

