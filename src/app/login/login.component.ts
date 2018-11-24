import { Component, EventEmitter, Output } from '@angular/core';
import { AuthenticationService } from '../shered';
import { Router } from '@angular/router';

@Component({
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  styles: [
    `
      input.alert{
        box-shadow: 0 0 0 .2rem rgb(173, 67, 85, 0.8);
      }
      span.alert{
        font-size: small;
        color: rgb(173, 67, 85);
        font-shadow: black 1.5px 1.5px
      }
      button.alert{
        cursor: not-allowed;
      }
      `
  ]
})
export class LoginComponent  {

  public username;
  public password;
  public invalidCred;

  public _auth: AuthenticationService;
  constructor(private auth: AuthenticationService, 
              public router: Router) {
                this._auth=auth;
              }

  ngOnInit(){
    alert('За привилегии студент username => student, за привилегии продекан username => prodekan, за привилегии настава било');
  }

  login(values){
    this.auth.login(values.username, values.password).subscribe(data =>{
      if(!data){
        this.invalidCred = true;
        if(!(this.router.url === '/login'))
        this.router.navigate(['/login']);
      } else{
        this.router.navigate(['/stream']);
      } 
    })
  }

}