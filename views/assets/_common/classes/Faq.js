class Faq {

    #id;
    #faqsCategoryId;
    #question;
    #answer;
    
    constructor(id, faqsCategoryId, question, answer) {

        this.#id = id;
        this.#faqsCategoryId = faqsCategoryId;
        this.#question = question;
        this.#answer = answer;
    }

    get id(){
        return this.#id;
    }

    set id(id){
       this.#id = id; 
    }

    get faqsCategoryId(){
        return this.#faqsCategoryId;
    }

    set faqsCategoryId(faqsCategoryId){
       this.#faqsCategoryId = faqsCategoryId; 
    }
    get question(){
        return this.#question;
    }

    set question(question){
       this.#question = question; 
    }
    get answer(){
        return this.#answer;
    }

    set answer(answer){
       this.#answer = answer; 
    }
}