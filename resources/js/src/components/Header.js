import React from 'react';

import { AppBar, Container, Toolbar, Typography, Button, Box, ButtonGroup, Avatar, InputBase, Chip   } from '@material-ui/core';
import PlusOneIcon from '@material-ui/icons/PlusOne';
import SearchIcon from '@material-ui/icons/Search';
import { fade, makeStyles } from '@material-ui/core/styles';

import Navbar from './Navbar';

const useStyles = makeStyles((theme) => ({
   wrapper: {
      justifyContent: 'space-between',
   },
   menuButton: {
      marginRight: theme.spacing(2),
   },
   logo: {
      flexGrow: 1,
      maxWidth: '200px',
      marginRight: '15px',
   },
   logoTitle: {
      fontSize: 22,
      fontWeight: 700,
      display: 'flex',
      justifyContent: 'space-between',
   },
   profile: {
      display: 'flex',
      alignItems: 'center',
   },
   user: {
      display: 'flex',
      alignItems: 'center',
   },
   userLabel: {
      display: 'flex',
      flexDirection: 'column',
      alignItems: 'center',
      marginLeft: '10px',
   },
   userRole:{
      fontSize: '12px'
   },
   search: {
      position: 'relative',
      borderRadius: theme.shape.borderRadius,
      backgroundColor: fade(theme.palette.common.white, 0.15),
      '&:hover': {
        backgroundColor: fade(theme.palette.common.white, 0.25),
      },
      marginLeft: 0,
      width: '100%',
      [theme.breakpoints.up('sm')]: {
        marginLeft: theme.spacing(1),
        width: 'auto',
      },
      marginRight: '10px',
    },
    searchIcon: {
      padding: theme.spacing(0, 2),
      height: '100%',
      position: 'absolute',
      pointerEvents: 'none',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
    },
    inputRoot: {
      color: 'inherit',

    },
    inputInput: {

      padding: theme.spacing(1, 1, 1, 0),
      paddingLeft: `calc(1em + ${theme.spacing(4)}px)`,
      transition: theme.transitions.create('width'),
      width: '100%',
      [theme.breakpoints.up('sm')]: {
        width: '12ch',
        '&:focus': {
          width: '20ch',
        },
      },
    },
}));

const Header = () => {
   const classes = useStyles();

   const [auth, setAuth] = React.useState(true);

   const handleChange = (event) => {
      setAuth(event.target.checked);
   };

   return (
      <AppBar position="fixed" className="header">
         <Container>
            <Toolbar className={classes.wrapper}>
               <Box className={classes.logo}>
                  <Typography className={classes.logoTitle}>
                     <span>U</span><span>S</span><span>O</span><span>F</span>
                  </Typography>

               </Box>
               <Box className={classes.profile}>
                  <div className={classes.search}>
                     <div className={classes.searchIcon}>
                        <SearchIcon />
                     </div>
                     <InputBase
                        placeholder="Search…"
                        classes={{
                           root: classes.inputRoot,
                           input: classes.inputInput,
                        }}
                        inputProps={{ 'aria-label': 'search' }}
                     />
                  </div>
                  {!auth && (
                  <ButtonGroup>
                     <Button variant="outlined" color="secondary">Login</Button>
                     <Button variant="contained" color="secondary" endIcon={<PlusOneIcon />}>Signup</Button>
                  </ButtonGroup>
                  )}
                  {auth && (
                  <Box className={classes.user}>
                     <Button variant="contained" color="secondary" size="small">Logout</Button>
                     <Box className={classes.userLabel}>
                        <Chip variant="outlined" color="secondary" label="Nickname" />
                     </Box>
                     <Box className={classes.userLabel}>
                        <Avatar alt="Cindy Baker" src="/uploads/images/avatars/avatar5.png" />
                        <Typography className={classes.userRole}>user</Typography>
                     </Box>
                  </Box>
                  )}
               </Box>
            </Toolbar>
         </Container>
         <Navbar />
      </AppBar>
   );
}

export default Header;