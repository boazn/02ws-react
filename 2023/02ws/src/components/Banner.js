import Button from 'react-bootstrap/Button';

const Btn = (props) => {
    return (
    <Button as="a" onClick={props.btnOnClick} >{props.btnTitleText}</Button>
    );
}

export default Btn; 