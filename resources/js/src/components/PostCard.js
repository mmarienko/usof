import React from 'react';
import { Link } from 'react-router-dom';

import { Typography, Card, CardContent, CardActions, Button, Avatar, Chip, Box, Tab, Tabs, AppBar } from '@material-ui/core';
import AvatarGroup from '@material-ui/lab/AvatarGroup';
import TabContext from '@material-ui/lab/TabContext';
import TabList from '@material-ui/lab/TabList';
import TabPanel from '@material-ui/lab/TabPanel';
import { makeStyles } from '@material-ui/core/styles';
const useStyles = makeStyles((theme) => ({
   root: {
      flex: '0 0 calc(33.33% - 2em)',
      [theme.breakpoints.down('sm')]: {
         flex: '0 0 calc(50% - 2em)',
       },
       [theme.breakpoints.down('xs')]: {
         flex: '0 0 calc(100% - 2em)',
       },
      backgroundColor: theme.palette.primary.light,
      margin: '1em',
      display: 'flex',
      flexDirection: 'column',

      "& .MuiAvatar-colorDefault": {
         color: theme.palette.primary.dark,
         backgroundColor: '#fff',
         borderColor: theme.palette.primary.dark,
      },
   },
   buttons: {
      display: 'flex',
      justifyContent: 'space-between',
   },
   chip: {
      margin: theme.spacing(0.2),
   },
}
));

const PostCard = () => {
   const classes = useStyles();
   const [value, setValue] = React.useState('1');

   const handleChange = (event, newValue) => {
      setValue(newValue);
   };

   return (
      <Card className={classes.root} variant="outlined">
         <CardContent>
            <Typography gutterBottom variant="h6">
               Word of the Day
            </Typography>
            <Box mb={1}>
               <Chip color="primary" label="C++" size="small" className={classes.chip} component={Link} to="/categories/1" style={{ cursor: 'pointer' }} />
               <Chip color="primary" label="Python" size="small" className={classes.chip} component={Link} to="/categories/1" style={{ cursor: 'pointer' }} />
               <Chip color="primary" label="Java" size="small" className={classes.chip} component={Link} to="/categories/1" style={{ cursor: 'pointer' }} />
            </Box>
            <Typography variant="body2" component="p">
               Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.
            </Typography>
         </CardContent>
         <Box style={{ flexGrow: '1' }}>
            <TabContext value={value} >
               <AppBar position="static">
                  <TabList
                     onChange={handleChange}
                     variant="scrollable"
                     scrollButtons="auto"
                     aria-label="simple tabs example">
                     <Tab label="First" value="1" />
                     <Tab label="Second" value="2" />
                     <Tab label="Third" value="3" />
                  </TabList>
               </AppBar>
               <TabPanel value="1">Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident.</TabPanel>
               <TabPanel value="2">Contrary to popular belief, Lorem Ipsum is not simply random text.</TabPanel>
               <TabPanel value="3">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour</TabPanel>
            </TabContext>
         </Box>

         <CardActions className={classes.buttons}>
            <Button variant="contained" color="secondary" size="small" style={{ width: '100%' }} component={Link} to="/post/1" >Show More</Button>
            <AvatarGroup max={4} appearance="stack">
               <Avatar alt="Remy Sharp" src="/uploads/images/avatars/avatar.png" component={Link} to="/profile/1" />
               <Avatar alt="Travis Howard" src="/uploads/images/avatars/avatar2.png" component={Link} to="/profile/1" />
               <Avatar alt="Cindy Baker" src="/uploads/images/avatars/avatar3.png" component={Link} to="/profile/1" />
               <Avatar alt="Agnes Walker" src="/uploads/images/avatars/avatar4.png" component={Link} to="/profile/1" />
               <Avatar alt="Trevor Henderson" src="/uploads/images/avatars/avatar5.png" component={Link} to="/profile/1" />
            </AvatarGroup>
         </CardActions>
      </Card>
   )
}

export default PostCard;