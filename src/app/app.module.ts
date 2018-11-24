import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { AuthenticationService } from './shered';
import { RouterModule } from '@angular/router';
import { appRoutes } from './routes';
import { JQ_TOKEN } from './common';
import { AuthGuardService } from './shered/authentication/auth-guard.service';
import { LoginGuardService } from './login/login-guard.service';
import { LiveStreamComponent } from './live-stream/live-stream.component';
import { ReportsComponent } from './reports/reports.component';
import { LiveStreamService } from './live-stream/live-stream.service';
import { LiveStreamResolver } from './live-stream/live-stream.resolver.service';
import { HttpClientModule } from '../../node_modules/@angular/common/http';
import { NavbarComponent } from './navbar/navbar.component';
import { NotificationComponent } from './navbar/notification.component';
import { NotificationService } from './navbar/notification.service';
import { NotificationResolver } from './navbar/notification.resolver';
import { ReportsService } from './reports/reports.service';
import { Globals } from './shered/globals';

let jQuery = window['$'];

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    LiveStreamComponent,
    ReportsComponent,
    NavbarComponent,
    NotificationComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule,
    RouterModule.forRoot(appRoutes)
    ],
  providers: [
    AuthenticationService,
    {provide: JQ_TOKEN, useValue: jQuery},
    AuthGuardService,
    LoginGuardService,
    LiveStreamService,
    LiveStreamResolver,
    NotificationService,
    NotificationResolver,
    ReportsService,
    Globals
    ],
  bootstrap: [AppComponent]
})
export class AppModule { }
export const backEndURL = '../backend';
export declare let scheduler: any;