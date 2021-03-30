import React, { render } from '@testing-library/react'
import App from './App'
import { shallow } from 'enzyme'

test('renders app', () => {
  const { getByText } = render(<App />)
  const h1Element = getByText(/Phone Directory/i)
  expect(h1Element).toBeInTheDocument()
})
