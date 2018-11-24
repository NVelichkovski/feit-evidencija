import { Injectable, OnChanges, Inject } from '@angular/core';
import { IUser } from '../user.model';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, ReplaySubject, BehaviorSubject } from 'rxjs';
import { Router } from '@angular/router';
import { tap, catchError } from 'rxjs/operators';
import { Globals } from '../globals';
import { JQ_TOKEN } from '../../common';
import { of as observableOf} from 'rxjs'

@Injectable()
export class AuthenticationService implements OnChanges {
  public currUser: IUser;  

  private setUser: BehaviorSubject<IUser> = new BehaviorSubject(undefined);
  public getUser: Observable<IUser> = this.setUser.asObservable();
  
  constructor(private http: HttpClient, 
              private router: Router, 
              private globals: Globals,
            @Inject(JQ_TOKEN) private $: any){}

  ngOnChanges() {}

  getServerUser() : Observable<any>{
    const options = {headers: new HttpHeaders({'Content-Type': 'application/json'})};
    return this.http.get<any>('api/authentication.php?action=get_user', options)
    .pipe(tap(data => {
      if(!!data)
      this.currUser=data;
    })) 
    .pipe(catchError(this.handleErrorLogOut<IUser>('AuthenticationService.login')));
  }

  logOut(): any {
    this.http.delete('api/authentication.php?action=logout').subscribe();
    this.currUser = undefined;
    this.setUser.next(undefined);
    this.globals.loading = false;
    this.router.navigate(['login']);
  }

  login(username, password){
      const options = {headers: new HttpHeaders({'Content-Type': 'application/json'})};
      return this.http.post<IUser>('api/authentication.php?action=login',
      {username: username, password: password},
      options)
      .pipe(tap(data=>{
        this.currUser=data;
        if(data){
          this.setUser.next(data);
        }else {
          this.setUser.next(undefined); 
        }
      }))
      .pipe(catchError(this.handleError<IUser>('AuthenticationService.login')));
    }

    private handleError<T>(operation = 'operation', result?: T) {
      return (error: any): Observable<T> => {
        console.error(error);
        this.$('#errorModal').modal();
        return observableOf(result as T);
      };
  }

  private handleErrorLogOut<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.error(error);
      this.$('#errorModal').modal();
      this.logOut();
      return observableOf(result as T);
    };
}
}
