import React, { Component,useContext } from 'react'
import PropTypes from 'prop-types'
import Dialog from '@material-ui/core/Dialog'
import Button from '@material-ui/core/Button'
import DialogContent from '@material-ui/core/DialogContent'
import DialogActions from '@material-ui/core/DialogActions'
import DialogTitle from '@material-ui/core/DialogTitle'
import { TodoContext } from '../contexts/TodoContext'
function DeleteDialog(props){
    const hide=()=>{
        console.log(props)
        props.setDeleteConfirmationIsShown(false)
        //        props.setDeleteConfirmationIsShown(false)
    }
    const context=useContext(TodoContext)
    return(
        <Dialog onClose={hide} open={props.open}>
            <DialogTitle>Are you sure you wish to delete this to-do ?</DialogTitle>
            <DialogContent>
                {props.todo.name}
            </DialogContent>
            <DialogActions>
                <Button onClick={hide}>Cancel</Button>
                <Button onClick={()=>{context.deleteTodo({id:props.todo.id,name:props.todo.name})
                hide()
            }}>Delete</Button>
            </DialogActions>
        </Dialog>
    );
}
DeleteDialog.propTypes={
    open:PropTypes.bool.isRequired,
    setDeleteConfirmationIsShown:PropTypes.func.isRequired,
    todo:PropTypes.shape=({
        id:PropTypes.number,
        name:PropTypes.string
    })
}
export default DeleteDialog
