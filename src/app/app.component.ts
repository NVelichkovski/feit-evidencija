import { Component, Output } from '@angular/core';
import { AuthenticationService } from './shered';
import { Globals } from './shered/globals';
import { Router, Event, NavigationStart, NavigationEnd } from '../../node_modules/@angular/router';
import { map } from 'rxjs/operators';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  public userLoggedIn: boolean;
  public loading: boolean = true;
  public _globals: Globals;
  constructor(private auth: AuthenticationService,
              private router: Router,
              private globals: Globals){
                this._globals = globals;
                this.router.events.subscribe((event: Event) => {
                  if(event instanceof NavigationStart){
                    this.loading = true;
                    console.log("Expect loading");
                  }
                  if(event instanceof NavigationEnd){
                    this.loading = false;
                  }
                })
    
    auth.getUser.pipe(map(data => !!data))
    .subscribe(data => {
      this.userLoggedIn = !!data;
    })
    
  }
  userLogged(event){
    this.userLoggedIn=true;
  }

  ngOnInit(){}
  
}
