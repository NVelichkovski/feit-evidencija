import { Component, OnInit } from '@angular/core';
import { LiveStreamService, IStreamInfo } from './live-stream.service';
import { AuthenticationService } from '../shered';
import {  ActivatedRoute } from '@angular/router';
import { Globals } from '../shered/globals';

@Component({
  templateUrl: './live-stream.component.html'
})
export class LiveStreamComponent implements OnInit {
  public _auth:AuthenticationService;
  public _liveStrService
  public streamingData: IStreamInfo[] = [];

  constructor(private auth: AuthenticationService, 
              private globals: Globals,
              private route: ActivatedRoute,
              private liveStrService: LiveStreamService) { 
                this._liveStrService = liveStrService;
                this._auth=auth;
  }

  ngOnInit() {
     this.streamingData = (this.route.snapshot.data['streamingData']).streamData;
     console.log('Data for following date:','2018-03-05 11:11:51.206344');     
  }

  updateStreamingData(){
    this.globals.loading = true;
    this.liveStrService.getStreamInfo().subscribe(data => {
      this.streamingData = data.streamData;
      this.globals.loading = false;
    });
  }
}