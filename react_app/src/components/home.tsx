import React ,{useState}from 'react'
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Button from 'react-bootstrap/Button';
import FormControl from 'react-bootstrap/FormControl';
import FormGroup from 'react-bootstrap/FormGroup';
import Accordion from 'react-bootstrap/Accordion';
import Lists from './lists'
import {readData , searchGoodTrpis} from '../services/data'
import * as uuid from "uuid";
import SweetAlert from 'react-bootstrap-sweetalert';


interface MyState {
    trips : Array<any>,
    from : String,
    errorMsg: String,
    destination: String
}

export default class Home extends React.Component<{}, MyState> {

    constructor(props){
        super(props)
        this.state = {
            trips : [],
            from : "",
            destination: "",
            errorMsg: ""
        }
        this.hideAlert  = this.hideAlert.bind(this)
        searchGoodTrpis("A","P")
    }

    async componentDidMount(){
        const data  = await readData();
        //this.setState({trips: data})
    }

    async handleClickSearch (e, from, to) {
        if(from.trim().length === 0 || to.trim().length === 0)
            return;
        var result = await searchGoodTrpis(from, to);
        if(result.length === 0 ){
            this.setState({errorMsg: `No trips found from ${from} to ${to}`})
        }
        this.setState({trips: result})
        
    }
    hideAlert(e){
        this.setState({errorMsg: ""})
    }
    render(){

            let uiData =[];
            this.state.trips.forEach(d => {
                uiData.push(<Lists data={d} key={uuid.v4()}></Lists>)
            });
            return (
                <Container >
                    <h1>Search </h1>
                    <SweetAlert title="coool" success onConfirm={this.hideAlert}  show={this.state.errorMsg !== ""} >{this.state.errorMsg}</SweetAlert>
                    <Row xs={12}>
                        <Col xs={5}>
                            <FormGroup>
                                <label>From</label>
                                <FormControl onChange={e => this.setState ({from :e.target.value})}/>
                            </FormGroup>
                        </Col>
                        <Col xs={5}>
                            <FormGroup>
                                <label>Destination</label>
                                <FormControl onChange={e => this.setState({destination :e.target.value})}/>
                            </FormGroup>
                        </Col>
                        <Col xs={2}><Button onClick={async e => await this.handleClickSearch(e,this.state.from, this.state.destination)} variant="primary">Search</Button></Col>
                    </Row>
                    <Row>
                        <Container fluid>
                            <Accordion defaultActiveKey="0" style={{marginTop: 20}}>
                                {uiData}
                            </Accordion>
                        </Container>
                    </Row>
                </Container>
            )
        }
}
