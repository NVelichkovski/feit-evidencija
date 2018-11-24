import { INotification, NotificationService } from "./notification.service";
import { Component, OnInit, EventEmitter, Output, Inject } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { filter } from "../../../node_modules/rxjs/operators";
import { JQ_TOKEN } from "../common";

@Component({
selector: 'app-notification',
templateUrl: './notification.component.html'
})
export class NotificationComponent implements OnInit{
    public notifications: INotification[] = [];
    public subjects: subject[] = [];
    @Output() numberOfNotifications: EventEmitter<number> = new EventEmitter();
    constructor(public notfService: NotificationService, 
                public http: HttpClient,
                @Inject(JQ_TOKEN) public $: any){}

    removeNotification(notificationElement, notificationHTML){
        this.$(notificationElement).collapse("dispose");
        this.notifications = this.notifications.filter(notification => notification.id !== notificationHTML.id);
    }                

    ngOnInit(){
        this.notfService.getNotifications()
        .subscribe(data =>{          
            if(data)
            this.notifications = data.notifications;
            this.subjects = data.subjects.map(element => {
                return {
                    id: element[1],
                    name: element['ime']
                }
            })
            this.subjects = this.subjects.filter((item, pos) => {
                let elementsById = this.subjects.map( element => element.id)
                return (elementsById.indexOf(item.id) == pos);
            })
            this.numberOfNotifications.emit(data.notifications.length)
        })
    }

    getOthersSubjects(notification){
        return this.subjects.filter(element => element.name != notification.subject);
    }
    
    sendExcuses(notification, values){
        
        let postObject = {
            status: notification.status,
            id: notification.id,
            tema: values.inputData
        }
        // console.log(postObject);
        // alert(notification.id)
        this.notfService.postNotification(postObject).subscribe(data => {
            // console.log(data);
            if(data)
            {
                if(notification.status=='одржана'){notification.status='одржанаТ';}
                else if(notification.status=='некорегирана'){notification.status='корегирана';}
                else if (notification.status=='неодржана'){notification.status='неодржанаТ';}
                notification.submited = 'yes';
                notification.tema = values.inputData;
                
                this.numberOfNotifications.emit(
                    this.notifications.filter(
                        notification => notification.tema == ""
                    ).length);
            }
        })
        notification.submited = 'waiting';
    }
    
}

interface subject{
    id: string,
    name: string
}