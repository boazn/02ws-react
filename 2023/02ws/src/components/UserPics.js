
const UserPics = (props) => {
    return (
        <div>
            {props.userPics.map((pic, i) => {
            return <div key={i}>
            <img src={`https://www.02ws.co.il/${pic.picname}`} height="230" width="230" alt="" ></img> 
        
            {pic.comment}<br/>{pic.name}
            </div>
            
            
            })}
        </div>
     );
}

export default UserPics; 