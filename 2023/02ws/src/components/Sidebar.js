
import { Outlet, Link } from "react-router-dom";
import { useState } from "react";
import '../css/navbar.css';

function Sidebar() {
    function do_something(){
    
    }
    
  
    const [isOpen, setIsOpen] = useState(false);
  
    function handleToggle(){
        setIsOpen(!isOpen);
    }
    return (
        <div id="sidebar">
                        
            <nav>
            <ul className={`links ${isOpen ? 'open': ''}`}>
                <li>
                <a href={`/Now/2`}>Current first</a>
                </li>
                <li>
                <Link to={`/App1`} onClick={() => do_something()} >Current </Link>
                </li>
                <li>
                <Link to={`/App2`} onClick={() => do_something()} >24H first</Link>
                </li>
                <li>
                <Link to={`/App3`} onClick={() => do_something()} >Nextdays first</Link>
                </li>
                <li>
                <Link to={`/AppExternal/1`} onClick={() => do_something()} >External</Link>
                </li>
                <li>
                <Link to={`/AppExternal/2`} onClick={() => do_something()} >External2</Link>
                </li>
            </ul>
            
            <div className={`menu ${isOpen ? 'open': ''}`} onClick={handleToggle}>
                <div className="hamburger"></div>
            </div>
            </nav>
        </div>
    )
}
export default Sidebar;
