class Photo {

    #id;
    #portfolioId;
    #link;

    constructor(id, portfolioId, link){

        this.#id = id;
        this.#portfolioId = portfolioId;
        this.#link = link;

    }

    get id(){
        return this.#id;
    }

    set id(id){
       this.#id = id; 
    }

    get portfolioId(){
        return this.#portfolioId;
    }

    set portfolioId(portfolioId){
       this.#portfolioId = portfolioId; 
    }
    get link(){
        return this.#link;
    }

    set link(link){
       this.#link = link; 
    }
 
    
}