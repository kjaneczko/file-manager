import React, {Component} from 'react';
import axios from 'axios';
import './css/FileManager.css';
import FolderTree from "./FolderTree";
import FolderContent from "./FolderContent";

class FileManager extends Component {
    constructor(props) {
        super(props);
        this.state = {
            folderTree: {
                tree: [],
                error: null
            },
            folderDir: 'uploads',
            folderContent: {
                content: [],
                error: null
            },
            isLoaded: false,
            error: null
        }
    }

    componentDidMount() {
        this.getFolderTree();
        this.getFolderContent();
    }

    getFolderTree() {
        axios({
            method: 'post',
            url: 'http://localhost:8000/api/folderTree.php',
            responseType: 'json',
        })
        .then(res => {
            this.setState({
                isLoaded: true,
                folderTree: {
                    tree: res.data.folderTree,
                    error: null,
                },
            });
        })
        .catch(err => {
            this.setState({
                isLoaded: true,
                folderTree: {
                    tree: [],
                    error: err,
                },
            });
        });
    }

    getFolderContent(dir = null) {
        axios({
            method: 'post',
            url: 'http://localhost:8000/api/folderContent.php',
            responseType: 'json',
            params: {
                folderDir: dir ? dir : this.state.folderDir
            },
        })
            .then(res => {
                console.log(res);
                this.setState({
                    folderContent: {
                        content: res.data.folderContent,
                        error: null,
                    }
                });
            })
            .catch(err => {
                console.log(err);
                this.setState({
                    folderContent: {
                        content: [],
                        error: err,
                    }
                });
            });
    }

    handleChangeDir(event) {
        this.setState({
            folderDir: event.target.dataset.dir,
        });
        this.getFolderContent(event.target.dataset.dir);
    }

    render() {
        console.log(this.state);
        return (
            <div className="FileManager">
                <FolderTree folderTree={this.state.folderTree.tree} handleChangeDir={(e) => this.handleChangeDir(e)} />
                <FolderContent folderContent={this.state.folderContent.content} handleChangeDir={(e) => this.handleChangeDir(e)} />
            </div>
        );
    }
}

export default FileManager;
