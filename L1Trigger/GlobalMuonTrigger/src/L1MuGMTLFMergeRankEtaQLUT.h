//-------------------------------------------------
//
/** \class L1MuGMTLFMergeRankEtaQLUT
 *
 *   LFMergeRankEtaQ look-up table
 *          
 *   this class was automatically generated by 
 *     L1MuGMTLUT::MakeSubClass()  
*/ 
//
//   Author :
//   H. Sakulin            HEPHY Vienna
//
//   Migrated to CMSSW:
//   I. Mikulec
//
//--------------------------------------------------
#ifndef L1TriggerGlobalMuonTrigger_L1MuGMTLFMergeRankEtaQLUT_h
#define L1TriggerGlobalMuonTrigger_L1MuGMTLFMergeRankEtaQLUT_h

//---------------
// C++ Headers --
//---------------


//----------------------
// Base Class Headers --
//----------------------
#include "L1Trigger/GlobalMuonTrigger/src/L1MuGMTLUT.h"

//------------------------------------
// Collaborating Class Declarations --
//------------------------------------

//              ---------------------
//              -- Class Interface --
//              ---------------------


class L1MuGMTLFMergeRankEtaQLUT : public L1MuGMTLUT {
  
 public:
  enum {DT, BRPC, CSC, FRPC};

  /// constuctor using function-lookup
  L1MuGMTLFMergeRankEtaQLUT() : L1MuGMTLUT("LFMergeRankEtaQ", 
				       "DT BRPC CSC FRPC",
				       "eta(6) q(3)",
				       "flag(1) rank_etaq(7)", 8, false) {
    InitParameters();
  } ;

  /// destructor
  virtual ~L1MuGMTLFMergeRankEtaQLUT() {};

  /// specific lookup function for flag
  unsigned SpecificLookup_flag (int idx, unsigned eta, unsigned q) const {
    std::vector<unsigned> addr(2);
    addr[0] = eta;
    addr[1] = q;
    return Lookup(idx, addr) [0];
  };

  /// specific lookup function for rank_etaq
  unsigned SpecificLookup_rank_etaq (int idx, unsigned eta, unsigned q) const {
    std::vector<unsigned> addr(2);
    addr[0] = eta;
    addr[1] = q;
    return Lookup(idx, addr) [1];
  };

  /// specific lookup function for entire output field
  unsigned SpecificLookup (int idx, unsigned eta, unsigned q) const {
    std::vector<unsigned> addr(2);
    addr[0] = eta;
    addr[1] = q;
    return LookupPacked(idx, addr);
  };



  /// access to lookup function with packed input and output

  virtual unsigned LookupFunctionPacked (int idx, unsigned address) const {
    std::vector<unsigned> addr = u2vec(address, m_Inputs);
    return TheLookupFunction(idx ,addr[0] ,addr[1]);

  };

 private:
  /// Initialize scales, configuration parameters, alignment constants, ...
  void InitParameters();

  /// The lookup function - here the functionality of the LUT is implemented
  unsigned TheLookupFunction (int idx, unsigned eta, unsigned q) const;

  /// Private data members (LUT parameters);
};
#endif



















