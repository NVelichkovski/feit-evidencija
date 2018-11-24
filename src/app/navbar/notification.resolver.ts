import { INotification, NotificationService } from "./notification.service";
import { Injectable } from "@angular/core";
import { Resolve } from "@angular/router";

@Injectable()
export class NotificationResolver implements Resolve<INotification[]>{

    constructor(public notfService: NotificationService){}
    
    resolve(){
        return this.notfService.getNotifications();
    }
}