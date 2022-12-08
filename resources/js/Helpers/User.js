import AppStorage from "./AppStorage";
import Token from "./Token";

class User{
    responseAfterLogin(res){
        const accessToken = res.token;
        const user = res.user;

        if(Token.isValid(accessToken)){
            AppStorage.store(accessToken,user);
        }
    }
}

export default User = new User();