import { Injectable, Inject } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";
import { tap, catchError } from "rxjs/operators";
import { AuthenticationService } from "../shered";
import { JQ_TOKEN } from "../common";
import { of as observableOf } from 'rxjs';

@Injectable()
export class LiveStreamService{    
    
    constructor(private http: HttpClient,
                private auth: AuthenticationService,
            @Inject(JQ_TOKEN) private $: any){}
    public semester: number;
    public streamingData: IStreamInfo[] = [];
    getStreamInfo(): Observable<any>{
        const options = {headers: new HttpHeaders({'Content-Type': 'application/json'})};
        return this.http.get<any>('api/sledenjevozivo.php', options)
        .pipe(catchError(this.handleError<any>('reports.postData', [])))
        .pipe(tap(data =>{
            this.semester=data.semester;
            if(this.semester===0){
               return data.streamData;
            }
            
        }));
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

export interface IStreamInfo{
    success: boolean,
    room: string,
    subject: string,
    professor: string,
    currently: string,
    present: number
}
