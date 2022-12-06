class Popup {
    constructor() {
        this.id = "popup";

        this.animation = "fade";

        this.icon = "";
        this.title = "Popup Title";

        this.bodyContent = "";

        this.submitButton = "Submit";
        this.neutralButton = "Cancel";

        this.padding = "";
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
                    '<div class="linear-center">' +
                        this.icon +
                        '<h2 class="ptitle">' + this.title + '</h2>' +
                    '</div>' +
                    '<button type="button" class="close-btn" data-dismiss="popup" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
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
                    '<button type="button" class="btn action-btn">' + this.submitButton + '</button>' +
                    '<button type="button" class="btn link-btn" data-dismiss="popup">' + this.neutralButton + '</button>' +
                '</div>';
    }

    render() {

        let popup = ' <div class="popup ' + this.animation + '" id="' + this.id + '" tabindex="-1" aria-hidden="true">' +
                    '<div class="pcontainer">' +
                        '<div class="pcontent">' +
                            this.getHeader() +
                            this.getBody() +
                            this.getFooter() +
                        '</div>' +
                    '</div>' +
                '</div>';

        console.log(popup);

        $("body").append(popup);
    }
}