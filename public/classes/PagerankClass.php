<?php
class Pagerank 
{
  private  $_links = array(); 
  private  $_graph = array();
  private function _get_id($url) {
    $ret = false;
    foreach($this->_links as $link) { //loop all links
    if ($link['link'] == $url) {
      $ret = $link['id']; //get mysql id
    }
  }
  return $ret;
}

  public function add_link($link, $to,$id) {
    $item['link'] = $link; //original url
    $item['to'] = $to; //array for links pointing to
    $item['id'] = $id; // mysql id
    $item['to_id'] = array();
    array_push($this->_links,$item);
  }
  private function _compute_ids() {
    foreach ($this->_links as $link) { //loop all links
      $this->_graph[$link['id']] = array();
      foreach ($link['to'] as $to) { // loop the links pointing to
        $to_id = $this->_get_id($to);
        if ($to_id != false ) { //if the link is registered, add it to the new graph with it's mysql id
          array_push($this->_graph[$link['id']],$to_id);
        }
      }
    }
  }
  private function _compute_pagerank($linkGraph, $dampingFactor = 0.15) {
    $pageRank = array();
    $tempRank = array();
    $nodeCount = count($linkGraph);
    // initialise the PR as 1/n
    foreach($linkGraph as $node => $outbound) {
      $pageRank[$node] = 1/$nodeCount;
      $tempRank[$node] = 0;
    } 
    $change = 1;
    $i = 0;
    while($change > 0.00005 && $i < 100) {
      $change = 0;
      $i++;
  
      // distribute the PR of each page
      foreach($linkGraph as $node => $outbound) {
        $outboundCount = count($outbound);
        foreach($outbound as $link) {
          $tempRank[$link] += $pageRank[$node] / $outboundCount;
        }
      }

      $total = 0;
      //   calculate the new PR using the damping factor
      foreach($linkGraph as $node => $outbound) {
        $tempRank[$node]  = ($dampingFactor / $nodeCount)
        + (1-$dampingFactor) * $tempRank[$node];
        $change += abs($pageRank[$node] - $tempRank[$node]);
        $pageRank[$node] = $tempRank[$node];
        $tempRank[$node] = 0;
        $total += $pageRank[$node];
      }
  
      // Normalise the page ranks so it's all a proportion 0-1
      foreach($pageRank as $node => $score) {
        $pageRank[$node] /= $total;
      }
    }
    return $pageRank;
  }

  public function calculate() {
    //print_r($this->_links);
    echo "<br><br>";
    $this->_compute_ids();
    $pagerank = $this->_compute_pagerank($this->_graph);
    foreach ($pagerank as $key => $value) {
        $sql = "UPDATE links SET pagerank = '" . $value . "' WHERE id='" . $key . "'";
        mysql_query($sql);
    }

  }
}
