import React from 'react'
import { Console } from 'console';



export const readData = async ()  => {
    var data = await fetch("/data.json")
    return JSON.parse(await data.text());
}

const getFirstTripByFrom = async (array, from: string) => {
    var data1 = array.filter(t => t.from === from);
    return data1.length === 0 ? null : data1[0];
}


const getFirstTripByDestination = async (array, to: string) => {
    var data2 = array.filter(t => t.to === to);
    return data2.length === 0 ? null : data2[0];
}


export const searchGoodTrpis  = async ( from: string, to: string) => {
    //console.log(allData)
    var tripsForFrom = (await readData()).sort(t => t.from === from? 1: -1);
    var tripsForTo = (await readData()).sort(t1 => t1.to === to ? -1: 1);

    var tripFrom = (await readData()).filter(t => t.from === from)
    var tripTo = (await readData()).filter(t => t.to === to)
    if(tripFrom.length === 0 || tripTo.length === 0) {
        return []
    }
    var to1 = to;
    var directTrip = (await readData()).filter(t => t.from === from && t.to === to);

    if(directTrip.length !== 0 )
        return [directTrip[0]];

    var listFrom: Array<any> = [];
    var listTo = []

    for(var j = 0; j < tripsForTo.length ; j++){
       // console.log(tripsForTo[j].to === to, tripsForTo[j].to , to)
        if(tripsForTo[j].to === to){
            var tempListTo = tripsForTo.filter(t => t.to === to);
            listTo.push(...tempListTo);
            if(await getFirstTripByDestination(tripsForTo, tripsForTo[j].from) == null){
                continue;
            }
            to = tripsForTo[j].from;
            tripsForTo.shift();
            tripsForTo = tripsForTo.sort((t,t1) => t.to === to ? 1:-1 );
            //console.log(to,tripsForTo)
            j=0;
        }
    }

    for(var i = 0; i < tripsForFrom.length ; i++){
        if(tripsForFrom[i].from === from){
            var tempListFrom = tripsForFrom.filter(t => t.from === from);
            listFrom.push(...tempListFrom);
            if(await getFirstTripByFrom(tripsForFrom, tripsForFrom[i].to) == null){
                continue;
            }
            from = tripsForFrom[i].to;
            tripsForFrom.shift();
            tripsForFrom = tripsForFrom.sort(t => t.from === from );
            i=0;
        }
    }
    
    var sameElements = listFrom.filter(compare(listTo));
    console.log(listTo,listFrom)
    return sameElements;
}

function compare(otherArray){
    return function(current){
      return otherArray.filter(function(other){
        return other.from == current.from && other.to == current.to
      }).length != 0;
    }
  }