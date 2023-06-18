

const Statuses = (props) => {
    return (
        <ul id="more_sigweather" className={"box_text " + (props.lang === 1? 'rtl' : '')}>
            <li>
            <ul id="sigweather">
                    {props.statuses.map((status, i) => {
                    return <li key={i}><a href={`https://www.02ws.co.il/${status.url}`}>{status.sigtitle1} - {status.sigext1} &nbsp;››</a></li>;
                })}
                
            </ul>
            </li>
        </ul>
    );
}

export default Statuses; 