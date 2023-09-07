import Button from 'react-bootstrap/Button';
import { ArrowDown,ArrowUp,ArrowLeft, ArrowRight, HandThumbsDown, HandThumbsUp, XLg } from 'react-bootstrap-icons';
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
        {props.img == "ArrowLeft" ?
         <ArrowLeft />
         : ''
        }
        {props.img == "ArrowRight" ?
         <ArrowRight />
         : ''
        }
        {props.img == "HandThumbsUp" ?
         <HandThumbsUp />
         : ''
        }
        {props.img == "HandThumbsDown" ?
         <HandThumbsDown />
         : ''
        }
         {props.img == "X" ?
         <XLg />
         : ''
        }
        {props.btnTitleText}
    </Button>
    );
}

export default Btn; 