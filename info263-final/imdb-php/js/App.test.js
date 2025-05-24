/*import React from 'react';
import { render, screen } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import App from './App';

test('renders homepage banner text', () => {
    render(
        <MemoryRouter initialEntries={['/']}>
            <App />
        </MemoryRouter>
    );
    expect(screen.getByText(/Never gonna tell a lie and hurt you/i)).toBeInTheDocument();
});

test('renders movies placeholder page', () => {
    render(
        <MemoryRouter initialEntries={['/movies']}>
            <App />
        </MemoryRouter>
    );
    expect(screen.getByText(/Movies Page Coming Soon/i)).toBeInTheDocument();
});

test('renders login link in navbar', () => {
    render(
        <MemoryRouter>
            <App />
        </MemoryRouter>
    );
    expect(screen.getByText(/Log In/i)).toBeInTheDocument();
});
