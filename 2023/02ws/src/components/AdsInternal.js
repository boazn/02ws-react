

const AdsInternal = (props) => {
    
    return (
    
    <div id="ads">
        {props.ads.map((ad, i) => {
             return <div key={i} a_key={i} >
                 <a href={ad.link} >
                    <img src={`https://www.02ws.co.il/${ad.img_url}`}  width={ad.width} height={ad.height} alt="ad" />
                 </a>
                 
             </div>;
          })}
    </div>
    );
}

export default AdsInternal; 