import { ResponsiveLine } from '@nivo/line';
import { getLatestArchiveData } from '../helpers/Utils';
import { React, useEffect, useState } from 'react';

const TempGraph = () => {
    const [jsondata, setJsonData] = useState([]);
    useEffect(() =>{
        const fetchJson = async () => {
            const data = await getLatestArchiveData(1000);
            setJsonData(data);
            console.log("getLatestArchiveData:"+data);
        }
        fetchJson();
    }, [])
    
    return (
        <ResponsiveLine
        data={jsondata}
        margin={{ top: 50, right: 110, bottom: 50, left: 60 }}
        xScale={{ 
            format: '%Y-%m-%d %H:%M:%S',
            precision: 'minute',
            type: 'time',
            useUTC: false}}
        yScale={{
            type: 'linear',
            min: 'auto',
            max: 'auto',
            stacked: false,
            reverse: false
        }}
        yFormat=" >-.2f"
        xFormat="time:%Y-%m-%d %H:%M:%S"
        axisTop={null}
        axisRight={null}
        axisBottom={{
            ticks:20,
            format: ' %H:%M',
            tickValues: 'every 30 minutes',
            tickSize: 1,
            tickPadding: 5,
            tickRotation: 90,
            legend: 'זמן',
            legendOffset: -12,
            legendPosition: 'middle'
        }}
        axisLeft={{
            tickSize: 5,
            tickPadding: 5,
            tickRotation: 0,
            legend: 'טמפרטורה',
            legendOffset: -40,
            legendPosition: 'middle'
        }}
        
        pointSize={0}
        pointColor={{ theme: 'background' }}
        pointBorderWidth={2}
        pointBorderColor={{ from: 'serieColor' }}
        pointLabelYOffset={-12}
        enableGridX={false}
        enableGridY={false}
        useMesh={true}
        legends={[
            {
                anchor: 'bottom-right',
                direction: 'column',
                justify: false,
                translateX: 100,
                translateY: 0,
                itemsSpacing: 0,
                itemDirection: 'left-to-right',
                itemWidth: 80,
                itemHeight: 20,
                itemOpacity: 0.75,
                symbolSize: 12,
                symbolShape: 'circle',
                symbolBorderColor: 'rgba(0, 0, 0, .5)',
                effects: [
                    {
                        on: 'hover',
                        style: {
                            itemBackground: 'rgba(0, 0, 0, .03)',
                            itemOpacity: 1
                        }
                    }
                ]
            }
        ]}
    />
    );
}

export default TempGraph;
