class Contact {

    #id;
    #userId;
    #text;


    constructor(id = null, userId = null, text = null) {

        this.#id = id;
        this.#userId = userId;
        this.#text = text;

    }


    get id() {
        return this.#id;
    }


    set id(id) {
        this.#id = id;
    }


    get userId() {
        return this.#userId;
    }


    set userId(userId) {
        this.#userId = userId;
    }


    get text() {
        return this.#text;
    }


    set text(text) {
        this.#text = text;
    }

}


export default Contact;