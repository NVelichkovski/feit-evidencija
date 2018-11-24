import { CanActivate, Router } from "@angular/router";
import { AuthenticationService } from "../shered";
import { Injectable } from "@angular/core";

@Injectable()
export class LoginGuardService implements CanActivate{
    constructor(public auth: AuthenticationService, 
        public router: Router){}

    canActivate(){
        return !this.auth.currUser;
    }
}