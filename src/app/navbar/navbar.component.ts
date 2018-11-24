import { Component, OnInit, OnChanges, Input, ElementRef, Inject, Output } from '@angular/core';
import { IUser, AuthenticationService } from '../shered';
import { Router } from '@angular/router';
import { JQ_TOKEN } from '../common';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: [
    '../../../node_modules/glyphicons-only-bootstrap/css/bootstrap.min.css',
    './navbar.component.css']
})
export class NavbarComponent implements OnInit {
  public currUser: IUser = undefined;
  public isLoggedIn: boolean = false;
  public access: string = '';
  
  public  _numberOfNotifications = 0;
  public _auth: AuthenticationService;

  constructor(public auth: AuthenticationService, 
              public router: Router,
    @Inject(JQ_TOKEN) public $: any,
      ){     
        this._auth=auth;
        this._router = router;                  
        auth.getUser.subscribe(data =>{
            if(!!data) 
            {
              this.access = data.access;
              this.isLoggedIn = true;
              this.currUser = <IUser>data;
            }
          })           
}



  updateNumberOfNotifications(value){
    this._numberOfNotifications=value;
   }

  public activeLink: string = 'stream';

  public _router: Router;  
  
 ngOnChanges(){
   this.currUser=this.auth.currUser;
   this.access=this.currUser.access;
   this.isLoggedIn = !!this.currUser;
 }
   
  ngOnInit() { }

   logOut(){
    this.currUser=undefined;
    this.access=undefined;
    this.isLoggedIn=false;    
     this.$('#app-notification').collapse('hide');  
     this.auth.logOut();
   }
   
}
