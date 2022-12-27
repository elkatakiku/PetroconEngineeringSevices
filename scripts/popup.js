class Popup {
    constructor() {
        this.type = "";
        this.size = "";

        this.color = "action";
        this.id = "popup";

        this.animation = "fade";
        this.location = "";

        this.top = "";
        this.right = "";
        this.bottom = "";
        this.left = "";

        this.icon = "";
        this.title = "Popup Title";

        this.bodyContent = "";

        this.submitButton = "Submit";
        this.neutralButton = "Cancel";

        this.padding = "";
    }

    setType(type) {
        this.type = "popup-" + type;
    }

    getType() {
        return this.type;
    }

    setSize(size) {
        this.size = "popup-" + size;
    }

    getSize() {
        return this.size;
    }

    setId(id) {
        this.id = id;
    }

    getId() {
        return this.id;
    }

    setTitle(title) {
        this.title = title;
    }

    getTitle() {
        return this.title;
    }

    setIcon(icon) {
        this.icon = icon;
    }

    getHeader() {
        return '<div class="pheader">' +
                    this.icon +
                    '<h2 class="ptitle">' + this.title + '</h2>' +
                    '<button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">'+
                        '<span class="material-icons">close</span>'+
                    '</button>'+
                '</div>';
    }

    setBodyContent(bodyContent) {
        this.bodyContent = bodyContent;
    }

    getBody() {
        return '<div class="pbody">' +
                    this.bodyContent +
                '</div>';
    }

    setSubmitButton(submitButton) {
        this.submitButton = submitButton;
    }

    setNeutralButton(neutralButton) {
        this.neutralButton = neutralButton;
    }

    getFooter() {
        return '<div class="pfooter">' +
                    '<button type="button" class="btn ' + this.color + '-btn">' + this.submitButton + '</button>' +
                    '<button type="button" class="btn link-btn" data-dismiss="popup">' + this.neutralButton + '</button>' +
                '</div>';
    }

    generatePopup() {

        return '<div class="popup show ' + this.animation + ' ' + this.location + ' ' + this.type + '" id="' + this.id + '" tabindex="-1" aria-hidden="true">' +
                        '<div class="pcontainer ' + this.size + '">' +
                            '<div class="pcontent">' +
                                this.getHeader() +
                                this.getBody() +
                                this.getFooter() +
                            '</div>' +
                        '</div>' +
                    '</div>';

        // console.log(popup);

        // $("body").append(popup);
    }
}