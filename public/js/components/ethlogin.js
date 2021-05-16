// const Web3 = require("web3");
import Web3 from '../../../node_modules/web3/dist/web3.min.js';

$("#login_submit").on("click", handleClick);

const handleClick = async () => {
    // Check if MetaMask is installed
    if (!(window).ethereum) {
        window.alert('Please install MetaMask first.');
        return;
    }

    if (!web3) {
        try {
            // Request account access if needed
            await (window).ethereum.enable();

            // We don't know window.web3 version, so we use our own instance of Web3
            // with the injected provider given by MetaMask
            web3 = new Web3((window).ethereum);
        } catch (error) {
            window.alert('You need to allow MetaMask.');
            return;
        }
    }

    const coinbase = await web3.eth.getCoinbase();
    if (!coinbase) {
        window.alert('Please activate MetaMask first.');
        return;
    }

    const publicAddress = coinbase.toLowerCase();
    setLoading(true);

    // Look if user with current publicAddress is already present on backend
    fetch(
        `${process.env.REACT_APP_BACKEND_URL}/users?publicAddress=${publicAddress}`
    )
        .then((response) => response.json())
        // If yes, retrieve it. If no, create it.
        .then((users) =>
            users.length ? users[0] : handleSignup(publicAddress)
        )
        // Popup MetaMask confirmation modal to sign message
        .then(handleSignMessage)
        // Send signature to backend on the /auth route
        .then(handleAuthenticate)
        // Pass accessToken back to parent component (to save it in localStorage)
        .then(onLoggedIn)
        .catch((err) => {
            window.alert(err);
            setLoading(false);
        });
    }

const handleSignup = publicAddress =>
    fetch(`${process.env.REACT_APP_BACKEND_URL}/users`, {
    body: JSON.stringify({ publicAddress }),
    headers: {
        'Content-Type': 'application/json'
    },
    method: 'POST'
}).then(response => response.json());

const handleSignMessage = ({ publicAddress, nonce }) => {
    return new Promise((resolve, reject) =>
        web3.personal.sign(
            web3.fromUtf8(`I am signing my one-time nonce: ${nonce}`),
            publicAddress,
            (err, signature) => {
            if (err) return reject(err);
            return resolve({ publicAddress, signature });
            }
        )
        );
    };

const handleAuthenticate = ({ publicAddress, signature }) =>
    fetch(`${process.env.REACT_APP_BACKEND_URL}/auth`, {
    body: JSON.stringify({ publicAddress, signature }),
    headers: {
        'Content-Type': 'application/json'
    },
    method: 'POST'
}).then(response => response.json());