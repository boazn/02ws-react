

const Statuses = (props) => {
    return (
        <ul id="more_sigweather" className={"box_text " + (props.lang === 1? 'rtl' : '')}>
            <li>
            <ul id="sigweather">
                    {props.statuses.map((status, i) => {
                        const title = eval(`status.sigtitle${props.lang}`);
                        const ext = eval(`status.sigext${props.lang}`);
                    return <li key={i}><a href={`https://www.02ws.co.il/${status.url}`}>{title} - {ext} &nbsp;››</a></li>;
                })}
                
            </ul>
            </li>
        </ul>
    );
}

export default Statuses; 