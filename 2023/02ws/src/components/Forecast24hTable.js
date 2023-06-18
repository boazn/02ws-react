import Button from 'react-bootstrap/Button';

const Forecast24hTable = (props) => {
    return (
    <Button as="a" onClick={props.btnOnClick} >{props.btnTitleText}</Button>
    );
}

export default Forecast24hTable; 