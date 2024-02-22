

const External = (props) => {
    return (
         <iframe src={props.src} width={props.width} height={props.height} title={props.title} scrolling="no" loading='eager' allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture full"></iframe>
    );
}

export default External; 