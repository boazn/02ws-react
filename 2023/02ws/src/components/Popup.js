import ReactModal  from 'react-modal';
import React, { useState } from 'react';

function Popup() {
    const [isOpen, setStateOpen] = useState(false);
    const setIsOpen = ({isOpen}) => {
        setStateOpen(isOpen);
    }
    
    return (
        <div>
        <ReactModal
        isOpen={isOpen}
        contentLabel="Example Modal"
        onRequestClose={() => setIsOpen(false)}
      >
        <p>content</p>
        <iframe src="https://www.02ws.co.il/small/?section=survey.php&amp;survey_id=2&amp;" width={320} height={600} sandbox='allow-scripts allow-modal' loading='eager' title="iframePopup"></iframe>
      </ReactModal>
    </div>
    );
}

export default Popup;