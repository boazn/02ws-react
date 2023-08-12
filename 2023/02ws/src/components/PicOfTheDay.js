import Btn from './Button';
import decodeUriComponent from 'decode-uri-component';
const PicOfTheDay = (props) => {
    const morePics = () => {
        alert('more pics ');
        };
    let latespic = decodeUriComponent(`${props.pic.caption1}`).replace(/\+/g, ' ');
    return (
        <div className="white_box">
        <img src={`https://www.02ws.co.il/${props.pic.picurl}`} height="230" alt="" className="rounded img-fluid float-start"></img> <br/>
    
        {latespic}<br/><br/>
        <Btn btnOnClick={() => morePics()} btnTitleText={" עוד"} />
        </div>
        
    );
}

export default PicOfTheDay; 