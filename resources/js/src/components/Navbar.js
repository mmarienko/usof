import React from 'react';
import { Link } from 'react-router-dom';


import { Container, Tabs, Tab } from '@material-ui/core';

const Navbar = () => {
  React.useEffect(() => {
    setValue(window.location.pathname);
  },[
    window.location.pathname
  ]);

  const [value, setValue] = React.useState('/');

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  return (
    <Container>
      <Tabs
        variant="fullWidth"
        value={value}
        scrollButtons="on"
        onChange={handleChange}
        aria-label="nav tabs example"
      >
        <Tab label="Home" component={Link} value="/" to="/" />
        <Tab label="Posts" component={Link} value="/posts" to="/posts" />
        <Tab label="Profile" component={Link} value="/profile" to="/profile" />
        <Tab label="About" component={Link} value="/about" to="/about" />
        <Tab label="Sponsor" component={Link} value="/sponsor" to="/sponsor" />
        <Tab label="Categories" component={Link} value="/categories" to="/categories" />
      </Tabs>
    </Container>
  );
}

export default Navbar;