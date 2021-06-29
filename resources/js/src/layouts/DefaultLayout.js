import React from 'react';

import Header from '../components/Header';
import Footer from '../components/Footer';

const Layout = ({ children }) => {
   return (
      <React.Fragment>
         <Header />
         <main className="main">{children}</main>
         <Footer />
      </React.Fragment>
   );
};
export default Layout;