import { Injectable, OnInit, Inject } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";
import { catchError } from "../../../node_modules/rxjs/operators";
import { AuthenticationService } from "../shered";
import { JQ_TOKEN } from "../common";
import { of as observableOf} from "rxjs"

@Injectable()
export class NotificationService implements OnInit{
    constructor(public http: HttpClient,
                public auth: AuthenticationService,
            @Inject(JQ_TOKEN) private $: any){}

    ngOnInit(){}

    getNotifications(): Observable<any>{
            const options = {headers: new HttpHeaders({'Content-Type': 'application/json'})};
            return this.http.get<INotification[]>('api/data/notifications.php?action=get_notifications', options)
            .pipe(catchError(this.handleError<any>('reports.postData', [])));
    }
    postNotification(postObject): Observable<boolean>{
        const options = {headers: new HttpHeaders({'Content-Type': 'text'})};
        return this.http.post<boolean>('api/data/notifications.php?action=submit', postObject, options)
        .pipe(catchError(this.handleError<any>('reports.postData', [])));
    }
    private handleError<T>(operation = 'operation', result?: T) {
        return (error: any): Observable<T> => {
          console.error(error);
          this.$('#errorModal').modal();
          this.auth.logOut();
          return observableOf(result as T);
        };
      }
}
export interface INotification{
    id: number,
    date: Date,
    subject: string,
    status: string,
    submited: string,
    tema: string
}