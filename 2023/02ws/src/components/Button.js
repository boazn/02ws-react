import Button from 'react-bootstrap/Button';
import { ArrowDown } from 'react-bootstrap-icons';
import { ArrowUp } from 'react-bootstrap-icons';
const Btn = (props) => {
    return (
    <Button as="b" onClick={props.btnOnClick} variant="light" >
        {props.img == "ArrowDown" ?
         <ArrowDown />
         : ''
        }
        {props.img == "ArrowUp" ?
         <ArrowUp />
         : ''
        }
        {props.btnTitleText}
    </Button>
    );
}

export default Btn; 