import React from 'react';

import BtnUp from './BtnUp';

import { Typography, Box, Container, Link } from '@material-ui/core';
import { makeStyles } from '@material-ui/core/styles';

const useStyles = makeStyles((theme) => ({
  title: {
    ...theme.typography.button,
    padding: theme.spacing(1),
    color: '#ffc400',
  },
}));

const Footer = () => {
  const classes = useStyles();

  return (
    <Box component="footer" className="footer">
      <BtnUp />
      <Container >
        <Typography variant="body1" className={classes.title} style={{textAlign:"right"}}>
          <Link href="https://github.com/mmarienko" color="inherit">
            Developed by Maksym Marienko
          </Link>
        </Typography>
      </Container>
    </Box>
  );
}

export default Footer;