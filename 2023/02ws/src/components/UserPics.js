import Btn from './Button';
const UserPics = (props) => {
    const morePics = () => {
        alert('more pics ');
        };
    return (
        <div className="white_box">
            {props.userPics.map((pic, i) => {
            return <div key={i}>
            <img src={`https://www.02ws.co.il/${pic.picname}`} height="230"  alt="" className="rounded img-fluid" ></img> <br/>
        
            {pic.comment}<br/>{pic.name}
            </div>
            
            
            })}
            <br/><br/>
        <Btn btnOnClick={() => morePics()} btnTitleText={" עוד"} />
        </div>
     );
}

export default UserPics; 