import React from 'react';

import PostCard from '../components/PostCard';

import {Container, Typography, Box, } from '@material-ui/core';
import { makeStyles } from '@material-ui/core/styles';

const useStyles = makeStyles((theme) => ({
   cardWrapper: {
      display: 'flex',
      flexWrap: 'wrap',
      justifyContent: 'space-between',

   },
   image: {
      color: '#fff',
      backgroundColor: theme.palette.primary.dark,
   },
   title: {
      color: '#fff',
      backgroundColor: theme.palette.primary.dark,
   }
}));

const Posts = () => {
   const classes = useStyles();

   return (
      <Box mt={0.5}>
            <Typography variant="h5" component="h3" className={classes.title} style={{ textAlign: "center", fontWeight: 700 }} >
               Last few questions..
            </Typography>

            <Container className={classes.cardWrapper}>
               <PostCard />
               <PostCard />
               <PostCard />
               <PostCard />
               <PostCard />
               <PostCard />
            </Container>
         </Box>
   )
}

export default Posts;