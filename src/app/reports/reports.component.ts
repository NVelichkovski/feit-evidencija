import { Component, OnInit, Inject } from '@angular/core';
import { IUser, AuthenticationService } from '../shered';
import { professor, subject, semester, ReportsService, subjectReport } from './reports.service';
import { JQ_TOKEN } from '../common';
import { Globals } from '../shered/globals';

@Component({
  templateUrl: './reports.component.html',
  styleUrls: ['./reports.component.css']
})
export class ReportsComponent implements OnInit {
  public predmet;
  public nedela;
  public semester;
  public nastavnik;

  public _auth: AuthenticationService;
  
  private professors: professor[] = [];
  private subjects: subject[] = [];
  public _semesters: semester[] = [];

  public _professors: professor[] = [];
  public _subjects: subject[] = [];

  public reportsData = [];
  public noReportsFeedback: boolean = false;

  public nedeli = ['1 недела','2 недела','3 недела','4 недела','5 недела','6 недела','7 недела','8 недела','9 недела','10 недела','11 недела','12 недела','13 недела','14 недела','15 недела',];
  constructor(private auth: AuthenticationService,
              private reportsService: ReportsService,
              private globals: Globals,
            @Inject(JQ_TOKEN) public $: any) {
    this._auth=auth;
    reportsService.getData().subscribe(data => {   
      this.professors = data.professors.filter((item, pos) => {
        let elementsById = data.professors.map( element => element.id)
        return (elementsById.indexOf(item.id) == pos);
    });
      this.subjects = data.subjects.filter((item, pos) => {
        let elementsById = data.subjects.map( element => element.id)        
        return (elementsById.indexOf(item.id) == pos);
    });
      this._semesters = data.semesters.filter((item, pos) => {
        let elementsById = data.semesters.map( element => element.id)
        return (elementsById.indexOf(item.id) == pos);
    });

      this._professors = this.professors;
      this._subjects = this.subjects;
    })
   }
   updateSubject(values){
     if(values.nastavnik =='-1'){
     this._subjects = this.subjects;
     this._professors = this.professors;
    //  this.$("#nastavnik").val(-1);
    }
     else{
    this._subjects = this.subjects
    .filter(element => element.professorId==values.nastavnik); 
    }
    // this.$("#predmet").val(-1);
   }

   updateProfessor(values){ 
     if(values.predmet =='-1'){
    this._subjects = this.subjects;
    this._professors = this.professors;
    // this.$("#predmet").val(-1);
   }else{
     let professorId = this.subjects.filter(element => {
      return element.id==values.predmet;
      })[0].professorId
    //  this.$("#nastavnik").val(professorId);
    }
}
  
  generateReport(values){
    this.globals.loading = true;
    this.reportsService.postData(values.nedela, values.semester, values.predmet, values.nastavnik)
    .subscribe( data => {            
            this.reportsData=data.subjects.sort(
              (element1, element2) => {
                if(new Date(element1.date) < new Date(element2.date)) return -1;
                if(new Date(element1.date) == new Date(element2.date)) return 0;
                if(new Date(element1.date) > new Date(element2.date)) return 1;
              }
            )            
            this.globals.loading = false;
            if(data.subjects.length == 0)
            this.noReportsFeedback = true;
            else  this.noReportsFeedback = false;
            
          })
  }

  getStudents(subject){
    return (subject.students.filter( student => student.recorded)).length;
  }
  ngOnInit() {
    // this.$("#predmet").val(-1);
    // this.$("#nastavnik").val(-1);
    // this.$("#semester").val(-1);
    // this.$("#nedela").val(-1);
  }

}
