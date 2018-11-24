import { Injectable, Inject } from '@angular/core';
import {  Observable, BehaviorSubject } from '../../../node_modules/rxjs';
import { HttpClient, HttpHeaders } from '../../../node_modules/@angular/common/http';
import { tap, catchError } from '../../../node_modules/rxjs/operators';
import { AuthenticationService } from '../shered';
import { JQ_TOKEN } from '../common';
import { Globals } from '../shered/globals';
import { of as observableOf} from "rxjs"

@Injectable()
export class ReportsService {
 
  public professors: professor[] = [];
  public subjects: subject[] = [];
  public semesters: semester[] = [];
  
  public reportsData: any[] = [];
  constructor(private http: HttpClient,
              private auth: AuthenticationService,
             @Inject(JQ_TOKEN) private $: any,
            private globals: Globals) {
   }

  public getData(): Observable<any>{
    const options = {headers: new HttpHeaders({'Content-Type': 'application/json'})};
    return this.http.get<any>('api/data/reports.php?action=get_params', options)
      .pipe(catchError(this.handleError<any>('reports.postData', [])))
      .pipe(tap(data => {
        this.professors = data.professors.filter((item, pos) => {
          let elementsById = this.professors.map( element => element.id)
          return (elementsById.indexOf(item.id) == pos);
      })
        this.subjects = data.subjects.filter((item, pos) => {
          let elementsById = this.subjects.map( element => element.id)
          return (elementsById.indexOf(item.id) == pos);
      });
        this.semesters = data.semesters.filter((item, pos) => {
          let elementsById = this.semesters.map( element => element.id)
          return (elementsById.indexOf(item.id) == pos);
      });
      }));
    }

    public postData(nedela, semestar, predmet, nastavnik ): Observable<any>{
      let postedData = {
        nedela: nedela,
        semestar: semestar,
        predmet: predmet,
        nastavnik: nastavnik
      };

      const options = {headers: new HttpHeaders({'Content-Type': 'application/json'})};
      return this.http.post<any>('api/data/reports.php?action=get_report',postedData, options)
        .pipe(catchError(this.handleError<any>('reports.postData', [])))
        .pipe(tap( data => {
          this.reportsData = data.subjects;
        }))
    }
    private handleError<T>(operation = 'operation', result?: T) {
      return (error: any): Observable<T> => {
        console.error(error);
        this.$('#errorModal').modal();
        // this.auth.logOut();
        this.globals.loading = false;
        return observableOf(result as T);
      };
    }
 
}

export interface professor{
  id: number,
  firstName: string, 
  lastName: string
}

export interface subject{
  id: number,
  name: string,
  professorId: number
}

export interface semester{
  id: number,
  name: string
}

export interface subjectReport{
  name: string,
  date: Date,
  proffesor: string,
  room: string,
  start_time: number,
  end_time: number,
  status: string,
  students: student[]
}

export interface student{
  name: string,
  index: string,
  recorded: boolean
}