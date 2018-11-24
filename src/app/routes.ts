import { Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { LoginGuardService } from './login/login-guard.service';
import { ReportsComponent } from './reports/reports.component';
import { AuthGuardService } from './shered/authentication/auth-guard.service';
// import { CalendarComponent } from './calendar/calendar.component';
import { LiveStreamComponent } from './live-stream/live-stream.component';
import { LiveStreamResolver } from './live-stream/live-stream.resolver.service';
export const appRoutes: Routes = [
    {path: 'login',  component: LoginComponent,  canActivate: [LoginGuardService]},
    {path: 'reports', component: ReportsComponent, canActivate: [AuthGuardService]},
    // {path: 'calendar', component: CalendarComponent, canActivate: [AuthGuardService]},
    {path: 'stream', component: LiveStreamComponent, resolve:{streamingData: LiveStreamResolver }, canActivate: [AuthGuardService]},
    {path: '', redirectTo: 'login', pathMatch: 'full'},
    {path: '**', redirectTo: 'login', pathMatch: 'full'}
];

