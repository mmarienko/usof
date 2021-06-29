import React from 'react';

import PostCard from '../components/PostCard';

import { Container, Typography, Card, CardActionArea, CardMedia, CardContent, Box } from '@material-ui/core';
import { makeStyles } from '@material-ui/core/styles';
const useStyles = makeStyles((theme) => ({
   cardWrapper: {
      display: 'flex',
      flexWrap: 'wrap',
      justifyContent: 'space-between',
   },
   image: {
      backgroundColor: theme.palette.primary.dark,
      color: '#fff',
   },
}));

const Home = () => {
   const classes = useStyles();

   return (
      <React.Fragment>
         <Card className={classes.image} square>
            <CardMedia
               component="img"
               alt="Contemplative Reptile"
               height="240"
               image="https://www.azoft.ru/wp-content/uploads/2012/10/code-review_main.jpg"
               title="Contemplative Reptile"
            />
            <Container>
               <CardContent>
                  <Typography gutterBottom variant="h5" component="h1">
                     Hello Everyone !
                  </Typography>
                  <Typography
                     variant="body1"
                     component="h2"
                  >
                     This is a project developed for ucode.world, used Stack: Laravel + React
                  </Typography>
               </CardContent>
            </Container>
         </Card>

         <Box mt={0.5}>
            <Container className={classes.cardWrapper}>
               <PostCard />
               <PostCard />
               <PostCard />
               <PostCard />
               <PostCard />
               <PostCard />
            </Container>
         </Box>

      </React.Fragment>
   )
}

export default Home;