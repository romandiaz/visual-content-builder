import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import './index.css';

// This is the entry point for our React application.
// We will render our main App component into the root element.
document.addEventListener('DOMContentLoaded', () => {
  const rootElement = document.getElementById('visual-builder-root');
  if (rootElement) {
    ReactDOM.render(<App />, rootElement);
  }
});
