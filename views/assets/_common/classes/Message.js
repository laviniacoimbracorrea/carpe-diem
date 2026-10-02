class Message {
    
    #id;
    #userPhotographerId;
    #userId;
    #message;
    
    constructor(id, userPhotographerId, userId, message){

        this.#id = id;
        this.#userPhotographerId = userPhotographerId;
        this.#userId = userId;
        this.#message = message;

    }

    get id(){
        return this.#id;
    }

    set id(id){
       this.#id = id; 
    }

    get userPhotographerId(){
        return this.#userPhotographerId;
    }

    set userPhotographerId(userPhotographerId){
       this.#userPhotographerId = userPhotographerId; 
    }
    get userId(){
        return this.#userId;
    }

    set userId(userId){
       this.#userId = userId; 
    }
    get message(){
        return this.#message;
    }

    set message(message){
       this.#message = message; 
    }
}