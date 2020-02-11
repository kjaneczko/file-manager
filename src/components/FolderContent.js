import React, {Component} from 'react';
import './css/FolderContent.css';

class FolderContent extends Component {
    constructor(props) {
        super(props);
    }

    displayFolderContent() {
        if(this.props.folderContent.length > 0) {
            const folderContentArr = [];
            this.props.folderContent.forEach((item, i) => {
                // folderContentArr.push(item.html);
                if(item.type === 'dir') {
                    folderContentArr.push(<span key={i} className="item folderIcon" data-dir={item.attributes['data-dir']} onClick={this.props.handleChangeDir}>{item.text}</span>);
                }
                else {
                    folderContentArr.push(<a key={i} className="item fileIcon" href={item.attributes.href} download>{item.text}</a>);
                }
            });
            return folderContentArr;
        }
        else {
            return <h2 className="emptyFolder">Empty folder</h2>
        }
    }

    render() {
        return (
            <div className="FolderContent">
                {this.displayFolderContent()}
            </div>
        );
    }
}

export default FolderContent;
