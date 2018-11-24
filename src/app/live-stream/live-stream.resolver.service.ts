import { IStreamInfo, LiveStreamService } from "./live-stream.service";
import { Resolve } from "@angular/router";
import { Injectable } from "@angular/core";

@Injectable()
export class LiveStreamResolver implements Resolve<IStreamInfo[]>{
    constructor(private liveStreamService: LiveStreamService){}
    resolve(){
        return this.liveStreamService.getStreamInfo();
    }
}