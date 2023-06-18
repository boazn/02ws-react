import decodeUriComponent from 'decode-uri-component';
const PicOfTheDay = (props) => {
    let latespic = decodeUriComponent(`${props.pic.caption1}`).replace(/\+/g, ' ');
    return (
        <div>
        <img src={`https://www.02ws.co.il/${props.pic.picurl}`} height="230" width="230" alt="" ></img> 
    
        {latespic}
        </div>
    );
}

export default PicOfTheDay; 