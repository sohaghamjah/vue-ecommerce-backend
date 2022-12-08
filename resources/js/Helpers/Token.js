class Token{
    isValid(token){
        const payload = this.payload(token);

        if(payload){
            return payload.iss = "http://127.0.0.1:8000/api/backend/" ? true : false;
        }

        return false;
    }

    payload(token){
        const payload = token.split('.')[1];
        return this.decode(payload)
    }

    decode(payload){
        return JSON.parse(atob(payload));
    }
}

export default Token = new Token();