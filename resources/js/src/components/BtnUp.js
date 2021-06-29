import React from 'react';

import { Zoom, Fab, useScrollTrigger } from '@material-ui/core';
import KeyboardArrowUpIcon from '@material-ui/icons/KeyboardArrowUp';
import { makeStyles } from '@material-ui/core/styles';

const useStyles = makeStyles((theme) => ({
    btnUp: {
        position: 'fixed',
        bottom: theme.spacing(2),
        right: theme.spacing(2),
    },
}));

const BtnUp = () => {
    const classes = useStyles();

    const trigger = useScrollTrigger({
        disableHysteresis: true,
        threshold: 100,
    });

    const handleClick = (event) => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    return (
        <Zoom in={trigger}>
            <Fab color="secondary" onClick={handleClick} size="small" aria-label="scroll back to top" className={classes.btnUp}>
                <KeyboardArrowUpIcon />
            </Fab>
        </Zoom>
    );
}

export default BtnUp;