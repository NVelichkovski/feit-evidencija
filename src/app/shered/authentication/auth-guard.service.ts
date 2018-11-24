import { Injectable, Inject } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router } from '@angular/router';
import { AuthenticationService } from './authentication.service';
import { tap } from '../../../../node_modules/rxjs/operators';
import { JQ_TOKEN } from '../../common';

@Injectable()
export class AuthGuardService implements CanActivate {

  constructor(public router: Router, 
              public auth: AuthenticationService,
              @Inject(JQ_TOKEN) public $: any) { }

  
    canActivate(route: ActivatedRouteSnapshot,state: RouterStateSnapshot) {

      if(this.router.url === '/')
     {
       return this.auth.getServerUser().toPromise().then(data =>{
        if(!data){
          this.router.navigate(['login']);
        }
        return !!data;
       });
     }
     
      if(!!this.auth.currUser)
     {
       console.log(this.$('#notificationElement'));
       this.$("#app-notification").collapse('hide');
       return true;
     }
     else{
       this.router.navigate(['/login'])
       return false;
     }
  }
}
