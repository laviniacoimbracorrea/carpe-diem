class Portfolio {
    
    #id;
    #userId;
    #title;
    #description;
    #coverLink;

    constructor(id, userId, title, description, coverLink){

        this.#id = id;
        this.#userId = userId;
        this.#title = title;
        this.#description = description;
        this.#coverLink = coverLink;

    }

   get id(){
        return this.#id;
    }

    set id(id){
       this.#id = id; 
    }

    get userId(){
        return this.#userId;
    }

    set userId(userId){
       this.#userId = userId; 
    }
    get title(){
        return this.#title;
    }

    set title(title){
       this.#title = title; 
    }
    get description(){
        return this.#description;
    }

    set description(description){
       this.#description = description; 
    }
    get coverLink(){
        return this.#coverLink;
    }

    set coverLink(coverLink){
       this.#coverLink = coverLink; 
    }
}