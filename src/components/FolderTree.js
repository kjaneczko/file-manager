import React, {Component} from 'react';
import './css/FolderTree.css';

class FolderTree extends Component {
    constructor(props) {
        super(props);
    }

    displayFolderTree(directoryArr) {
        const folderTreeArr = [];
        directoryArr.forEach((folder, i) => {
            if(folder.subfolders.length > 0) {
                folderTreeArr.push(<li key={i}><span data-dir={folder.path} onClick={this.props.handleChangeDir}>{folder.folder_name}</span> [+] <ul>{this.displayFolderTree(folder.subfolders)}</ul></li>);
            }
            else {
                folderTreeArr.push(<li key={i}><span data-dir={folder.path} onClick={this.props.handleChangeDir}>{folder.folder_name}</span></li>);
            }
        });
        return folderTreeArr;
    }

    render() {
        return (
            <div className="FolderTree">
                <ul>
                    {this.displayFolderTree(this.props.folderTree)}
                </ul>
            </div>
        );
    }
}

export default FolderTree;
